package com.anggarad.dev.bangunganku.ui.home

import android.Manifest
import android.content.Context
import android.content.Intent
import android.content.pm.PackageManager
import android.location.Geocoder
import android.location.Location
import android.location.LocationManager
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.core.content.ContextCompat
import androidx.fragment.app.Fragment
import androidx.lifecycle.ViewModelProvider
import androidx.recyclerview.widget.LinearLayoutManager
import com.anggarad.dev.bangunganku.data.source.local.entity.CardMenuEntity
import com.anggarad.dev.bangunganku.databinding.FragmentHomeBinding
import com.anggarad.dev.bangunganku.ui.adapter.DataCallback
import com.anggarad.dev.bangunganku.ui.service.building.ServiceReportActivity
import com.google.android.gms.location.FusedLocationProviderClient
import com.google.android.gms.location.LocationServices
import java.util.*

@Suppress("DEPRECATION")
class HomeFragment : Fragment(), DataCallback {

    private lateinit var binding: FragmentHomeBinding
    private lateinit var viewModel: HomeViewModel
    private lateinit var lastLocation: Location
    private lateinit var fusedLocationProviderClient: FusedLocationProviderClient
    private lateinit var locationManager: LocationManager

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        viewModel = ViewModelProvider(this).get(HomeViewModel::class.java)
        binding = FragmentHomeBinding.inflate(layoutInflater, container, false)
        return binding.root


    }


    override fun onActivityCreated(savedInstanceState: Bundle?) {
        super.onActivityCreated(savedInstanceState)

        if (activity != null) {
            val viewModel = ViewModelProvider(
                this,
                ViewModelProvider.NewInstanceFactory()
            )[HomeViewModel::class.java]
            val menu = viewModel.getCardMenuData()

            val homeAdapter = HomeAdapter(this@HomeFragment)
            homeAdapter.setMenu(menu)

            with(binding.rvMenu) {
                layoutManager = LinearLayoutManager(context)
                setHasFixedSize(true)
                adapter = homeAdapter

            }
        }
        fusedLocationProviderClient =
            LocationServices.getFusedLocationProviderClient(activity?.applicationContext)
        setUpLocationPermission()
    }


    @Suppress("DEPRECATION")
    private fun setUpLocationPermission() {
        if (activity?.let {
                ContextCompat.checkSelfPermission(
                    it, Manifest.permission.ACCESS_FINE_LOCATION
                ) != PackageManager.PERMISSION_GRANTED &&
                        ContextCompat.checkSelfPermission(
                            it, Manifest.permission.ACCESS_COARSE_LOCATION
                        ) != PackageManager.PERMISSION_GRANTED
            } == true
        ) {
            requestPermissions(
                arrayOf(
                    Manifest.permission.ACCESS_FINE_LOCATION,
                    Manifest.permission.ACCESS_COARSE_LOCATION
                ), 101
            )
        }

        locationManager = activity?.getSystemService(Context.LOCATION_SERVICE) as LocationManager


        fusedLocationProviderClient.lastLocation.addOnSuccessListener { location ->
            if (location != null) {
                lastLocation = location
                setLocation(lastLocation)
            }
        }
    }

    private fun setLocation(location: Location) {

        var geocoder = Geocoder(requireContext(), Locale.getDefault())
        var addresses = geocoder.getFromLocation(location.latitude, location.longitude, 2)
        var address = addresses[0]


        binding.tvLocation.text = "${address.subAdminArea}"

    }

    override fun onMenuClick(data: CardMenuEntity) {
        if(lastLocation != null){
            startActivity(
                Intent(
                    context, ServiceReportActivity::class.java
                )
                    .putExtra(ServiceReportActivity.TYPE_BUILDING, data.menuId)
                    .putExtra(ServiceReportActivity.EXTRA_LOCATION, lastLocation)
            )
        } else{
            Toast.makeText(requireContext(), "wait for locationa", Toast.LENGTH_SHORT).show()
        }

    }

}



