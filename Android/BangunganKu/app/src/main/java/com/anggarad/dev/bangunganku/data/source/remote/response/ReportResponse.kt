package com.anggarad.dev.bangunganku.data.source.remote.response

import com.google.gson.annotations.SerializedName


data class ReportResponse(

	@field:SerializedName("response")
	val response: Boolean,

	@field:SerializedName("message")
	val message: String? = null,
)
