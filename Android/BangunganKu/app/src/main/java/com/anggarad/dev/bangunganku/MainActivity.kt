package com.anggarad.dev.bangunganku

import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.asLiveData
import com.anggarad.dev.bangunganku.data.UserPreferences
import com.anggarad.dev.bangunganku.ui.auth.AuthActivity
import com.anggarad.dev.bangunganku.ui.home.HomeActivity
import com.anggarad.dev.bangunganku.ui.startNewActivity

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        val userPref = UserPreferences(this)

        userPref.accessToken.asLiveData().observe(this, {
            val activity = if (it == null) AuthActivity::class.java else HomeActivity::class.java
            startNewActivity(activity)
        })

//        startActivity(Intent(this, AuthActivity::class.java))
    }
}