package com.anggarad.dev.bangunganku.data.source.remote.response

import android.os.Parcelable
import com.google.gson.annotations.SerializedName
import kotlinx.parcelize.Parcelize

data class UserResponse(

	@field:SerializedName("data")
	val data: DataUser,

	@field:SerializedName("response")
	val response: Boolean,

	@field:SerializedName("message")
	val message: String,

)
data class DataUser(

	@field:SerializedName("photo")
	val photo: String,

	@field:SerializedName("role")
	val role: String,

	@field:SerializedName("province")
	val province: String,

	@field:SerializedName("phone")
	val phone: String,

	@field:SerializedName("city")
	val city: String,

	@field:SerializedName("id")
	val id: String,

	@field:SerializedName("fullname")
	val fullname: String,

	@field:SerializedName("email")
	val email: String,

	@field:SerializedName("log_report")
	val logReport: ReportResponse? = null,
)
