package com.anggarad.dev.bangunganku.data.repository

import com.anggarad.dev.bangunganku.data.UserPreferences
import com.anggarad.dev.bangunganku.data.network.ApiService
import okhttp3.MultipartBody
import okhttp3.RequestBody

class ReportRepository(
    private val api: ApiService,
    private val preferences: UserPreferences,
) : BaseRepository() {

    suspend fun scanRoad(fileName: String, body: RequestBody) = safeApiCall {
        api.scanRoad(
            MultipartBody.Part.createFormData("file", fileName, body)
        )
    }

    suspend fun scanBuilding(fileName: String, body: RequestBody) = safeApiCall {
        api.scanBuilding(
            MultipartBody.Part.createFormData("file", fileName, body)
        )
    }

    suspend fun saveProcessToken(processToken: String) {
        preferences.saveProcessToken(processToken)
    }

    suspend fun submitReport(
        fullname: String,
        buildType: String,
        address: String,
        geocordinate: String,
    ) = safeApiCall {
        api.submitReport(fullname, buildType, address, geocordinate)
    }

//    suspend fun saveCredentialsForReport(token: String, userName: String) {
//        preferences.saveUserCredentials(token, userName)
//    }
}