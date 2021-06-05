package com.anggarad.dev.bangunganku.ui.service.building

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.anggarad.dev.bangunganku.data.network.Resource
import com.anggarad.dev.bangunganku.data.repository.UserRepository
import com.anggarad.dev.bangunganku.data.source.remote.response.ReportResponse
import com.anggarad.dev.bangunganku.data.source.remote.response.UserResponse
import kotlinx.coroutines.launch

class ServiceReportViewModel(
    private val repository: UserRepository
) : ViewModel() {

    private val _dataUser: MutableLiveData<Resource<UserResponse>> = MutableLiveData()
    val dataUser: LiveData<Resource<UserResponse>> = _dataUser

    private val _reportResponse: MutableLiveData<Resource<ReportResponse>> = MutableLiveData()
    val reportResponse: LiveData<Resource<ReportResponse>> = _reportResponse

    fun getUser() = viewModelScope.launch {
        _dataUser.value = repository.getUser()
    }

//     fun postReport(
//        name: String,
//        address: String,
//        coordinate: LatLng,
//        damageLvl: String,
//        buildingType: String,
//        photo: String) : Job
//    {
//        return viewModelScope.launch {
//            _reportResponse.value = Resource.Loading
//            _reportResponse.value = repository.postReport(name, address,coordinate, damageLvl, buildingType, photo)
//        }
//
//    }
}