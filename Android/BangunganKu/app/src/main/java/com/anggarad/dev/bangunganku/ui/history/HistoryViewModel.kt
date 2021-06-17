package com.anggarad.dev.bangunganku.ui.history

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.anggarad.dev.bangunganku.data.network.Resource
import com.anggarad.dev.bangunganku.data.repository.UserRepository
import com.anggarad.dev.bangunganku.data.source.remote.response.HistoryResponse
import kotlinx.coroutines.launch

class HistoryViewModel(
    private val repos: UserRepository,
) : ViewModel() {

    private val _dataHistory: MutableLiveData<Resource<List<HistoryResponse>>> =
        MutableLiveData()
    val dataHistory: LiveData<Resource<List<HistoryResponse>>> = _dataHistory

    fun getUserHistory() = viewModelScope.launch {
        _dataHistory.value = repos.getUserHistory()
    }
}