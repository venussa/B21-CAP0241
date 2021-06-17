package com.anggarad.dev.bangunganku.data.network

import com.anggarad.dev.bangunganku.data.source.remote.response.LoginResponse
import com.anggarad.dev.bangunganku.data.source.remote.response.RegisterResponse
import com.anggarad.dev.bangunganku.data.source.remote.response.ReportResponse
import com.anggarad.dev.bangunganku.data.source.remote.response.ScanResponse
import okhttp3.MultipartBody
import retrofit2.http.*

interface ApiService {

    @FormUrlEncoded
    @POST("service_login")
    suspend fun userLogin(
        @Field("email") email: String,
        @Field("password") password: String,
    ): LoginResponse

    @FormUrlEncoded
    @POST("service_register")
    suspend fun userRegistration(
        @Field("email") email: String,
        @Field("fullname") fullname: String,
        @Field("phone") phone: String,
        @Field("province") province: String,
        @Field("city") city: String,
        @Field("password") password: String,
        @Field("repassword") confirmPassword: String,
    ): RegisterResponse

    @Multipart
    @POST("service_scan_building")
    suspend fun scanBuilding(
        @Part file: MultipartBody.Part,
    ): ScanResponse

    @Multipart
    @POST("service_scan_road")
    suspend fun scanRoad(
        @Part file: MultipartBody.Part,
    ): ScanResponse

    @FormUrlEncoded
    @POST("service_report")
    suspend fun submitReport(
        @Field("fullname") fullname: String,
        @Field("buildtype") buildtype: String,
        @Field("address") address: String,
        @Field("geocordinate") geocordinate: String,
    ): ReportResponse


}