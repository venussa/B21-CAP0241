package com.anggarad.dev.bangunganku.data.source.remote.response

import com.google.gson.annotations.SerializedName

data class ListReportResponse<T>(

    @field:SerializedName("log_report")
    val logReport: List<T>? = null,
)
