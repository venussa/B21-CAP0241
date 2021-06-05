package com.anggarad.dev.bangunganku.viewmodel

import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import com.anggarad.dev.bangunganku.data.repository.AuthRepository
import com.anggarad.dev.bangunganku.data.repository.BaseRepository
import com.anggarad.dev.bangunganku.data.repository.UserRepository
import com.anggarad.dev.bangunganku.ui.auth.AuthViewModel
import com.anggarad.dev.bangunganku.ui.profile.ProfileViewModel

class ViewModelFactory(private val repository: BaseRepository) :
    ViewModelProvider.NewInstanceFactory() {

    override fun <T : ViewModel?> create(modelClass: Class<T>): T {
        return when {
            modelClass.isAssignableFrom(AuthViewModel::class.java) -> AuthViewModel(repository as AuthRepository) as T
            modelClass.isAssignableFrom(ProfileViewModel::class.java) -> ProfileViewModel(repository as UserRepository) as T
            else -> throw IllegalArgumentException("ViewModel Class Not Found")
        }
    }

}