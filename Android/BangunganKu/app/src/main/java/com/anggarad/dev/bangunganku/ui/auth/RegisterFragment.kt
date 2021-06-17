package com.anggarad.dev.bangunganku.ui.auth

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.core.widget.addTextChangedListener
import androidx.fragment.app.FragmentTransaction
import com.anggarad.dev.bangunganku.R
import com.anggarad.dev.bangunganku.data.network.ApiService
import com.anggarad.dev.bangunganku.data.network.Resource
import com.anggarad.dev.bangunganku.data.repository.AuthRepository
import com.anggarad.dev.bangunganku.databinding.FragmentRegisterBinding
import com.anggarad.dev.bangunganku.ui.base.BaseFragment
import com.anggarad.dev.bangunganku.ui.enable
import com.anggarad.dev.bangunganku.ui.handleApiError


@Suppress("DEPRECATION")
class RegisterFragment : BaseFragment<AuthViewModel, FragmentRegisterBinding, AuthRepository>() {
    private lateinit var transaction: FragmentTransaction

    override fun onActivityCreated(savedInstanceState: Bundle?) {
        super.onActivityCreated(savedInstanceState)

        transaction = requireActivity().supportFragmentManager.beginTransaction()
        val loginFragment = LoginFragment()

        binding.registerButton.enable(false)



        viewModel.registerResponse.observe(viewLifecycleOwner, {
            when (it) {
                is Resource.Success -> {
                    if (!it.value.response) {
                        Toast.makeText(requireContext(),
                            "Please fill all the Data",
                            Toast.LENGTH_SHORT).show()
                    } else {
                        Toast.makeText(requireContext(), "Registration Success", Toast.LENGTH_SHORT)
                            .show()
                        transaction.apply {
                            replace(R.id.fragment, loginFragment)
                            setTransition(FragmentTransaction.TRANSIT_FRAGMENT_CLOSE)
                            commit()
                        }
                    }
                }
                is Resource.Failure -> handleApiError(it)
            }
        })



        binding.editRegistrationConfirmPass.addTextChangedListener {
            val phone = binding.editRegistrationPhone.text.toString().trim()
            val email = binding.editRegistrationEmail.text.toString().trim()
            val password = binding.editRegistrationPass.text.toString().trim()
            val fullname = binding.editRegistrationFullName.text.toString().trim()
            val province = binding.provinceData.text.toString().trim()
            val cityData = binding.cityData.text.toString().trim()
            binding.registerButton.enable(
                phone.isNotEmpty() &&
                        email.isNotEmpty() &&
                        password.isNotEmpty() &&
                        fullname.isNotEmpty() &&
                        province.isNotEmpty() &&
                        cityData.isNotEmpty() &&
                        it.toString().isNotEmpty())
        }

        binding.registerButton.setOnClickListener {
            val phone = binding.editRegistrationPhone.text.toString().trim()
            val email = binding.editRegistrationEmail.text.toString().trim()
            val password = binding.editRegistrationPass.text.toString().trim()
            val confirmPass = binding.editRegistrationConfirmPass.text.toString().trim()
            val province = binding.provinceData.text.toString().trim()
            val cityData = binding.cityData.text.toString().trim()
            val fullname = binding.editRegistrationFullName.text.toString().trim()
            viewModel.register(email,
                fullname,
                phone,
                province,
                cityData,
                password,
                confirmPass)
        }
    }


    override fun getViewModel(): Class<AuthViewModel> {
        return AuthViewModel::class.java
    }

    override fun getFragmentBinding(
        inflater: LayoutInflater,
        container: ViewGroup?,
    ): FragmentRegisterBinding {
        return FragmentRegisterBinding.inflate(inflater, container, false)
    }

    override fun getFragmentRepos(): AuthRepository {
        return AuthRepository(remoteDataSource.getApiService(ApiService::class.java),
            userPref)
    }

}