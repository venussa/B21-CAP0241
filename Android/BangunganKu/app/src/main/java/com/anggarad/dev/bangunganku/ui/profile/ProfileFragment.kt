package com.anggarad.dev.bangunganku.ui.profile

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.lifecycle.lifecycleScope
import com.anggarad.dev.bangunganku.R
import com.anggarad.dev.bangunganku.data.network.Resource
import com.anggarad.dev.bangunganku.data.network.UserApi
import com.anggarad.dev.bangunganku.data.repository.UserRepository
import com.anggarad.dev.bangunganku.data.source.remote.response.DataUser
import com.anggarad.dev.bangunganku.databinding.FragmentProfileBinding
import com.anggarad.dev.bangunganku.ui.auth.AuthActivity
import com.anggarad.dev.bangunganku.ui.base.BaseFragment
import com.anggarad.dev.bangunganku.ui.startNewActivity
import com.anggarad.dev.bangunganku.ui.visible
import com.bumptech.glide.Glide
import com.bumptech.glide.request.RequestOptions
import kotlinx.coroutines.flow.first
import kotlinx.coroutines.launch
import kotlinx.coroutines.runBlocking

class ProfileFragment : BaseFragment<ProfileViewModel, FragmentProfileBinding, UserRepository>() {
    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.progressBar.visible(false)

        viewModel.getUser()

        viewModel.dataUser.observe(viewLifecycleOwner, {
            when (it) {
                is Resource.Success -> {
                    if (!it.value.response){
                        Toast.makeText(requireContext(), it.value.message, Toast.LENGTH_SHORT).show()
                        requireActivity().startNewActivity(AuthActivity::class.java)
                    }else{
                        binding.progressBar.visible(false)
                        updateUI(it.value.data)
                    }
                }
                is Resource.Loading -> {
                    binding.progressBar.visible(true)
                }
                is Resource.Failure -> {
                    Toast.makeText(requireContext(), "Can't Load Data", Toast.LENGTH_SHORT).show()
                }
            }
        })

        binding.logoutButton.setOnClickListener {
            lifecycleScope.launch() {
                userPref.logout()
            }
            requireActivity().startNewActivity(AuthActivity::class.java)
            Toast.makeText(requireContext(), "Logged Out", Toast.LENGTH_SHORT).show()
        }

        binding.btnManageProfile.setOnClickListener {
            Toast.makeText(requireContext(), "Under Development", Toast.LENGTH_SHORT).show()
        }
    }

    private fun updateUI(dataUser: DataUser) {
        val name = runBlocking { userPref.getUserName.first() }
        with(binding) {
            tvUsersName.text = name

                tvEmail.text = dataUser.email
                Glide.with(root.context)
                    .load(dataUser.photo)
                    .placeholder(R.drawable.ic_baseline_person_24)
                    .apply(RequestOptions()
                        .override(110, 110))
                    .into(userPicture)

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