package com.anggarad.dev.bangunganku.ui.base

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import androidx.lifecycle.lifecycleScope
import androidx.viewbinding.ViewBinding
import com.anggarad.dev.bangunganku.data.UserPreferences
import com.anggarad.dev.bangunganku.data.network.RemoteDataSource
import com.anggarad.dev.bangunganku.data.repository.BaseRepository
import com.anggarad.dev.bangunganku.viewmodel.ViewModelFactory
import kotlinx.coroutines.flow.first
import kotlinx.coroutines.launch


abstract class BaseFragment<VM : ViewModel, Binding : ViewBinding, Repos : BaseRepository> :
    Fragment() {

    protected lateinit var userPref: UserPreferences
    protected lateinit var binding: Binding
    protected lateinit var viewModel: VM
    protected val remoteDataSource = RemoteDataSource()

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        userPref = UserPreferences(requireContext())
        binding = getFragmentBinding(inflater, container)
        val factory = ViewModelFactory(getFragmentRepos())
        viewModel = ViewModelProvider(this, factory).get(getViewModel())

        lifecycleScope.launch { userPref.accessToken.first() }

        return binding.root

    }

    abstract fun getViewModel(): Class<VM>

    abstract fun getFragmentBinding(inflater: LayoutInflater, container: ViewGroup?): Binding

    abstract fun getFragmentRepos(): Repos
}