package com.anggarad.dev.bangunganku.data.repository

import com.anggarad.dev.bangunganku.data.network.UserApi

class UserRepository(
    private val api: UserApi,
) : BaseRepository() {


    suspend fun getUserData() = safeApiCall {
        api.getUserData()
    }

    suspend fun getUserHistory() = safeApiCall {
        api.getUserHistory().data.logReport

    }

}
