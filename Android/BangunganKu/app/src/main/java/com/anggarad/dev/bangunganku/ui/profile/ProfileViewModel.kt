package com.anggarad.dev.bangunganku.ui.profile

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.anggarad.dev.bangunganku.data.network.Resource
import com.anggarad.dev.bangunganku.data.repository.UserRepository
import com.anggarad.dev.bangunganku.data.source.remote.response.UserResponse
import kotlinx.coroutines.launch

class ProfileViewModel(
    private val repository: UserRepository
) : ViewModel() {

    private val _dataUser: MutableLiveData<Resource<UserResponse>> = MutableLiveData()
    val dataUser: LiveData<Resource<UserResponse>>
        get() = _dataUser

    fun getUser() = viewModelScope.launch {
        _dataUser.value = repository.getUser()
    }
}