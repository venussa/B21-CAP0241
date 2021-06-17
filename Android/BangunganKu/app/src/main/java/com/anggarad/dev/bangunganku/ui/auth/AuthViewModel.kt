package com.anggarad.dev.bangunganku.ui.auth

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.anggarad.dev.bangunganku.data.network.Resource
import com.anggarad.dev.bangunganku.data.repository.AuthRepository
import com.anggarad.dev.bangunganku.data.source.remote.response.LoginResponse
import com.anggarad.dev.bangunganku.data.source.remote.response.RegisterResponse
import kotlinx.coroutines.Job
import kotlinx.coroutines.launch

class AuthViewModel(private val repos: AuthRepository) : ViewModel() {

    private val _loginResponse: MutableLiveData<Resource<LoginResponse>> = MutableLiveData()
    val loginResponse: LiveData<Resource<LoginResponse>> = _loginResponse

    private val _registerResponse: MutableLiveData<Resource<RegisterResponse>> = MutableLiveData()
    val registerResponse: LiveData<Resource<RegisterResponse>> = _registerResponse


    fun login(email: String, password: String): Job {
        return viewModelScope.launch {
            _loginResponse.value = Resource.Loading
            _loginResponse.value = repos.userLogin(email, password)
        }
    }

    suspend fun saveCredentials(token: String, userName: String) {
        repos.saveCredentials(token, userName)
    }

    fun register(
        email: String,
        fullname: String,
        phone: String,
        province: String,
        city: String,
        password: String,
        confirmPassword: String,
    ): Job {
        return viewModelScope.launch {
            _registerResponse.value = Resource.Loading
            _registerResponse.value = repos.userRegistration(email,
                fullname,
                phone,
                province,
                city,
                password,
                confirmPassword)
        }
    }

}