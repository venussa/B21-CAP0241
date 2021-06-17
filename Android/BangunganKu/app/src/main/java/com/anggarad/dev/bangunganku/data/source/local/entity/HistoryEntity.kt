package com.anggarad.dev.bangunganku.data.source.local.entity

import android.os.Parcelable
import kotlinx.parcelize.Parcelize

@Parcelize
data class HistoryEntity(

	val image: String,

	val address: String,

	val buildtype: String,

	val damageLvl: String,

	val scanType: String,

	val processToken: String,

	val datetime: String,

	val geocordinate: String,

	val verifiedTimestamp: String,

	val id: Int,

	val fullname: String,

	val email: String,

	val status: Int,
) : Parcelable
