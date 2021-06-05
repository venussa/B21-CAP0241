package com.anggarad.dev.bangunganku.ui.profile

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import com.anggarad.dev.bangunganku.data.network.Resource
import com.anggarad.dev.bangunganku.data.network.UserApi
import com.anggarad.dev.bangunganku.data.repository.UserRepository
import com.anggarad.dev.bangunganku.data.source.remote.response.DataUser
import com.anggarad.dev.bangunganku.databinding.FragmentProfileBinding
import com.anggarad.dev.bangunganku.ui.auth.AuthActivity
import com.anggarad.dev.bangunganku.ui.base.BaseFragment
import com.anggarad.dev.bangunganku.ui.startNewActivity
import com.anggarad.dev.bangunganku.ui.visible
import kotlinx.coroutines.flow.first
import kotlinx.coroutines.runBlocking

class ProfileFragment() : BaseFragment<ProfileViewModel, FragmentProfileBinding, UserRepository>() {

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.progressBar.visible(false)

        viewModel.getUser()

        viewModel.dataUser.observe(viewLifecycleOwner, {
            when (it) {
                is Resource.Success -> {
                    binding.progressBar.visible(false)
                    updateUI(it.value.data)
                }
                is Resource.Loading -> {
                    binding.progressBar.visible(true)
                }
                is Resource.Failure -> {
                    Toast.makeText(requireContext(), "Gagal memuat data", Toast.LENGTH_SHORT).show()
                }
            }
        })

        binding.logoutButton.setOnClickListener {
            runBlocking {
                userPref.logout()
            }
            requireActivity().startNewActivity(AuthActivity::class.java)
            Toast.makeText(requireContext(), "Logged Out", Toast.LENGTH_SHORT).show()
        }
    }

    private fun updateUI(dataUser: DataUser) {
        with(binding) {
            tvUsersName.text = dataUser.fullname
            tvCity.text = dataUser.city
        }
    }

    override fun getViewModel(): Class<ProfileViewModel> {
        return ProfileViewModel::class.java
    }

    override fun getFragmentBinding(
        inflater: LayoutInflater,
        container: ViewGroup?
    ): FragmentProfileBinding {
        return FragmentProfileBinding.inflate(inflater, container, false)
    }

    override fun getFragmentRepos(): UserRepository {

        val token = runBlocking { userPref.accessToken.first() }
        val api = remoteDataSource.getApiService(UserApi::class.java, token)
        return UserRepository(api)
    }
}