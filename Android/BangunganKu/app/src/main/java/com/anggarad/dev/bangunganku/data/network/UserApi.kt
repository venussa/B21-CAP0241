package com.anggarad.dev.bangunganku.data.network

import com.anggarad.dev.bangunganku.data.source.remote.response.UserResponse
import retrofit2.http.GET

interface UserApi {

    @GET("service_my_data")
    suspend fun getUserData(): UserResponse

    @GET("service_my_data")
    suspend fun getUserHistory(): UserResponse
}