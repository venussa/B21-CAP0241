package com.anggarad.dev.bangunganku.data.network

import com.anggarad.dev.bangunganku.data.source.remote.response.UserResponse
import retrofit2.http.GET

interface UserApi {

    @GET("service_my_data")
    suspend fun getUser(): UserResponse

//    @POST("service_report")
//    suspend fun postReport(
//        fullname: String,
//        address: String,
//        coordinate: LatLng,
//        damageLvl: String,
//        buildingType: String,
//        photo: String
//    ): ReportResponse
}