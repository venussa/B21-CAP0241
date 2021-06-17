package com.anggarad.dev.bangunganku.ui.service.building

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.anggarad.dev.bangunganku.data.network.Resource
import com.anggarad.dev.bangunganku.data.repository.ReportRepository
import com.anggarad.dev.bangunganku.data.source.remote.response.ReportResponse
import com.anggarad.dev.bangunganku.data.source.remote.response.ScanResponse
import kotlinx.coroutines.Job
import kotlinx.coroutines.launch
import okhttp3.RequestBody

class ServiceReportViewModel(
    private val repository: ReportRepository,
) : ViewModel() {

    private val _reportResponse: MutableLiveData<Resource<ReportResponse>> = MutableLiveData()
    val reportResponse: LiveData<Resource<ReportResponse>> = _reportResponse

    private val _scanResponse: MutableLiveData<Resource<ScanResponse>> = MutableLiveData()
    val scanResponse: LiveData<Resource<ScanResponse>> = _scanResponse


    suspend fun getProcessToken(newProcessToken: String) {
        repository.saveProcessToken(newProcessToken)
    }


    fun submitReport(
        fullname: String,
        buildType: String,
        address: String,
        geocordinate: String,
    ): Job {
        return viewModelScope.launch {
            _reportResponse.value = Resource.Loading
            _reportResponse.value =
                repository.submitReport(fullname, buildType, address, geocordinate)
        }

    }

    fun scanBuilding(filename: String, body: RequestBody): Job {
        return viewModelScope.launch {
            _scanResponse.value = Resource.Loading
            _scanResponse.value = repository.scanBuilding(filename, body)
        }
    }

    fun scanRoad(filename: String, body: RequestBody): Job {
        return viewModelScope.launch {
            _scanResponse.value = Resource.Loading
            _scanResponse.value = repository.scanRoad(filename, body)
        }
    }
}