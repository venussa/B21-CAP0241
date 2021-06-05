package com.anggarad.dev.bangunganku.data.repository

import com.anggarad.dev.bangunganku.data.network.Resource
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext
import okhttp3.ResponseBody
import retrofit2.HttpException

abstract class BaseRepository {

    suspend fun <T> safeApiCall(
        apiCall: suspend () -> T
    ): Resource<T> {
        return withContext(Dispatchers.IO) {
            try {
                Resource.Success(apiCall.invoke())
            } catch (t: Throwable) {
                when (t) {
                    is HttpException -> {
                        Resource.Failure(
                            false, t.code(), t.response()?.errorBody(),
                            t.response()?.body() as ResponseBody?
                        )

                    }
                    else -> {
                        Resource.Failure(true, null, null, null)
                    }

                }
            }
        }
    }


}