package com.anggarad.dev.bangunganku.data.source.remote.response

import android.os.Parcelable
import com.google.gson.annotations.SerializedName
import kotlinx.android.parcel.Parcelize

@Parcelize
data class ReportResponse(

	@field:SerializedName("image")
	val image: String? = null,

	@field:SerializedName("address")
	val address: String? = null,

	@field:SerializedName("buildtype")
	val buildtype: String? = null,

	@field:SerializedName("damage_lvl")
	val damageLvl: String? = null,

	@field:SerializedName("scan_type")
	val scanType: String? = null,

	@field:SerializedName("process_token")
	val processToken: String? = null,

	@field:SerializedName("datetime")
	val datetime: String? = null,

	@field:SerializedName("geocordinate")
	val geocordinate: String? = null,

	@field:SerializedName("verified_timestamp")
	val verifiedTimestamp: String? = null,

	@field:SerializedName("id")
	val id: Int? = null,

	@field:SerializedName("fullname")
	val fullname: String? = null,

	@field:SerializedName("email")
	val email: String? = null,

	@field:SerializedName("status")
	val status: Int? = null
) : Parcelable
