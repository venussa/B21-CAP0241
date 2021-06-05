package com.anggarad.dev.bangunganku.data

import android.content.Context
import androidx.datastore.DataStore
import androidx.datastore.preferences.*
import kotlinx.coroutines.flow.Flow
import kotlinx.coroutines.flow.map


class UserPreferences(context: Context) {
    private val applicationContext = context.applicationContext
    private val dataStore: DataStore<Preferences> = applicationContext.createDataStore(
        name = "user data store"
    )

    companion object {
        private val KEY_AUTH = preferencesKey<String>("key_auth")
    }

    val accessToken: Flow<String?>
        get() {
            return dataStore.data.map { preferences ->
                preferences[KEY_AUTH]
            }
        }

    suspend fun saveUserCredentials(accessToken: String) {
        dataStore.edit { preferences ->
            preferences[KEY_AUTH] = accessToken
        }
    }

    suspend fun logout() {
        dataStore.edit { it.clear() }
    }

}