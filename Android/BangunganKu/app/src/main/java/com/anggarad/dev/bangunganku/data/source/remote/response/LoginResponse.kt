package com.anggarad.dev.bangunganku.data.source.remote.response

import com.google.gson.annotations.SerializedName

data class LoginResponse(

	@field:SerializedName("code")
	val code: Int,

	@field:SerializedName("data")
	val data: Data,

	@field:SerializedName("response")
	val response: Boolean,

	@field:SerializedName("message")
	val message: String,

	@field:SerializedName("access_token")
	val accessToken: String?,

	@field:SerializedName("expired")
	val expired: String,
)

data class Data(


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

	@field:SerializedName("register_time")
	val registerTime: String,

	@field:SerializedName("login_time")
	val loginTime: String,
)
