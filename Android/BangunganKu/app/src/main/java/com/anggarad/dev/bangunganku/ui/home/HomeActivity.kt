package com.anggarad.dev.bangunganku.ui.home

import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.navigation.findNavController
import androidx.navigation.ui.setupWithNavController
import com.anggarad.dev.bangunganku.R
import com.anggarad.dev.bangunganku.databinding.ActivityHomeBinding

class HomeActivity : AppCompatActivity() {

    private lateinit var binding: ActivityHomeBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityHomeBinding.inflate(layoutInflater)
        setContentView(binding.root)


        val bottomNavigationView = binding.navView
        val navController = findNavController(R.id.navHostFragmentHome)

        bottomNavigationView.setupWithNavController(navController)

    }
}