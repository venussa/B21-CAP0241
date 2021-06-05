package com.anggarad.dev.bangunganku.data.network

import com.anggarad.dev.bangunganku.BuildConfig
import okhttp3.OkHttpClient
import okhttp3.logging.HttpLoggingInterceptor
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

class RemoteDataSource {
    companion object {
        private const val BASE_URL = "http://34.101.207.154/"
    }
        fun <Api> getApiService(
            api: Class<Api>,
            accessToken: String? = null
        ): Api {
            val loggingInterceptor =
                HttpLoggingInterceptor().setLevel(HttpLoggingInterceptor.Level.BODY)
            val client = OkHttpClient.Builder()
                .addInterceptor { chain ->
                    chain.proceed(chain.request().newBuilder().also {
                        it.addHeader("token", "$accessToken")
                    }.build())
                }
                .also {
                    if (BuildConfig.DEBUG) {
                        it.addInterceptor(loggingInterceptor)
                    }
                }

                .build()
            val retrofit = Retrofit.Builder()
                .baseUrl(BASE_URL)
                .addConverterFactory(GsonConverterFactory.create())
                .client(client)
                .build()
            return retrofit.create(api)
        }
    }