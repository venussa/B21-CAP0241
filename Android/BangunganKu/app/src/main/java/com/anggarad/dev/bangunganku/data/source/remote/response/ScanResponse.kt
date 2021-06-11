package com.anggarad.dev.bangunganku.data.source.remote.response

import com.google.gson.annotations.SerializedName

data class ScanResponse(

    @field:SerializedName("response")
    val response: Boolean,

    @field:SerializedName("process_token")
    val processToken: String,

    @field:SerializedName("date_time")
    val dateTime: String? = null,

    @field:SerializedName("image")
    val image: String,

    @field:SerializedName("message")
    val message: String? = null,

    @field:SerializedName("damagelevel")
    val damageLevel: String,

    @field:SerializedName("scantype")
    val scanType: String? = null,
)
