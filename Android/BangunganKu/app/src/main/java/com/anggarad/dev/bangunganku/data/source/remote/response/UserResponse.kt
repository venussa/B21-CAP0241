package com.anggarad.dev.bangunganku.data.source.remote.response

import com.google.gson.annotations.SerializedName

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
	val logReport: List<HistoryResponse>,
)

data class HistoryResponse(

	@field:SerializedName("image")
	val image: String,

	@field:SerializedName("address")
	val address: String,

	@field:SerializedName("buildtype")
	val buildtype: String,

	@field:SerializedName("damage_lvl")
	val damageLvl: String,

	@field:SerializedName("scan_type")
	val scanType: String,

	@field:SerializedName("process_token")
	val processToken: String,

	@field:SerializedName("datetime")
	val datetime: String,

	@field:SerializedName("geocordinate")
	val geocordinate: String,

	@field:SerializedName("verified_timestamp")
	val verifiedTimestamp: String,

	@field:SerializedName("id")
	val id: Int,

	@field:SerializedName("fullname")
	val fullname: String,

	@field:SerializedName("email")
	val email: String,

	@field:SerializedName("status")
	val status: Int,
)
