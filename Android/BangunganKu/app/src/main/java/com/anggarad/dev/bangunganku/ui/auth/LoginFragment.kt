@file:Suppress("DEPRECATION")

package com.anggarad.dev.bangunganku.ui.auth

import android.os.Bundle
import android.view.LayoutInflater
import android.view.ViewGroup
import android.widget.Toast
import androidx.core.widget.addTextChangedListener
import androidx.lifecycle.lifecycleScope
import com.anggarad.dev.bangunganku.data.network.ApiService
import com.anggarad.dev.bangunganku.data.network.Resource
import com.anggarad.dev.bangunganku.data.repository.AuthRepository
import com.anggarad.dev.bangunganku.databinding.FragmentLoginBinding
import com.anggarad.dev.bangunganku.ui.base.BaseFragment
import com.anggarad.dev.bangunganku.ui.enable
import com.anggarad.dev.bangunganku.ui.handleApiError
import com.anggarad.dev.bangunganku.ui.home.HomeActivity
import com.anggarad.dev.bangunganku.ui.startNewActivity
import com.anggarad.dev.bangunganku.ui.visible
import kotlinx.coroutines.launch

class LoginFragment : BaseFragment<AuthViewModel, FragmentLoginBinding, AuthRepository>() {

    override fun onActivityCreated(savedInstanceState: Bundle?) {
        super.onActivityCreated(savedInstanceState)

        binding.progressBar.visible(false)
        binding.loginButton.enable(false)

        viewModel.loginResponse.observe(viewLifecycleOwner, {
            binding.progressBar.visible(it is Resource.Loading)
            when (it) {
                is Resource.Success -> {
                    if (!it.value.response) {
                        Toast.makeText(requireContext(), "Login Failed", Toast.LENGTH_SHORT).show()
                    } else {
                        lifecycleScope.launch {
                            viewModel.saveCredentials(it.value.accessToken!!)
                            Toast.makeText(
                                requireContext(),
                                "Welcome ${it.value.data.fullname}",
                                Toast.LENGTH_SHORT
                            ).show()
                            requireActivity().startNewActivity(HomeActivity::class.java)
                        }
                    }
                }

                is Resource.Failure -> handleApiError(it)
            }
        })

        binding.editTextTextPassword.addTextChangedListener {
            val email = binding.editTextTextEmailAddress.text.toString().trim()
            binding.loginButton.enable(email.isNotEmpty() && it.toString().isNotEmpty())
        }

        binding.loginButton.setOnClickListener {
            val email = binding.editTextTextEmailAddress.text.toString().trim()
            val password = binding.editTextTextPassword.text.toString().trim()
            viewModel.login(email, password)

        }
    }

    override fun getViewModel(): Class<AuthViewModel> {
        return AuthViewModel::class.java
    }

    override fun getFragmentBinding(
        inflater: LayoutInflater,
        container: ViewGroup?
    ): FragmentLoginBinding {
        return FragmentLoginBinding.inflate(inflater, container, false)
    }

    override fun getFragmentRepos(): AuthRepository {
        return AuthRepository(remoteDataSource.getApiService(ApiService::class.java), userPref)
    }
}