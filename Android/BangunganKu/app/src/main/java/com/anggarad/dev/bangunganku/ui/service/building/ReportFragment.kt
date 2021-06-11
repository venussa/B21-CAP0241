package com.anggarad.dev.bangunganku.ui.service.building

import android.location.Geocoder
import android.location.Location
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.core.widget.addTextChangedListener
import com.anggarad.dev.bangunganku.data.network.ApiService
import com.anggarad.dev.bangunganku.data.network.Resource
import com.anggarad.dev.bangunganku.data.repository.ReportRepository
import com.anggarad.dev.bangunganku.databinding.FragmentReportBinding
import com.anggarad.dev.bangunganku.ui.base.BaseFragment
import com.anggarad.dev.bangunganku.ui.enable
import com.anggarad.dev.bangunganku.ui.home.HomeActivity
import com.anggarad.dev.bangunganku.ui.snackbar
import com.anggarad.dev.bangunganku.ui.startNewActivity
import kotlinx.coroutines.flow.first
import kotlinx.coroutines.runBlocking
import java.util.*


class ReportFragment :
    BaseFragment<ServiceReportViewModel, FragmentReportBinding, ReportRepository>() {
    private var name: String? = null
    private var inputLocation: Location? = null


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        name = runBlocking { userPref.getUserName.first() }
        binding.tvNameReport.text = name

        postReport()

        inputLocation = arguments?.getParcelable("location")
        inputLocation?.let {
            binding.tvAddressReport.text = setLocation(it)
        }


    }


    override fun getViewModel(): Class<ServiceReportViewModel> {
        return ServiceReportViewModel::class.java
    }

    override fun getFragmentBinding(
        inflater: LayoutInflater,
        container: ViewGroup?,
    ): FragmentReportBinding {
        return FragmentReportBinding.inflate(inflater, container, false)


    }

    override fun getFragmentRepos(): ReportRepository {
        val processToken = arguments?.getString("processToken")
        val token = runBlocking { userPref.accessToken.first() }
        val api = remoteDataSource.getApiService(
            ApiService::class.java,
            token,
            processToken
        )
        return ReportRepository(api, userPref)
    }

    private fun setLocation(location: Location): String {

        var geocoder = Geocoder(requireContext(), Locale.getDefault())
        var addresses = geocoder.getFromLocation(location.latitude, location.longitude, 2)
        var address = addresses?.get(0)

        return "${address?.getAddressLine(0)}"

    }

    fun postReport() {
        viewModel.reportResponse.observe(viewLifecycleOwner, {
            when (it) {
                is Resource.Success -> {
                    if (!it.value.response) {
                        binding.root.snackbar("Process Token is Missing")
                    } else {
                        Toast.makeText(requireContext(), "Report Posted", Toast.LENGTH_SHORT).show()
                        requireActivity().startNewActivity(HomeActivity::class.java)
                    }
                }
                is Resource.Failure -> {
                    binding.root.snackbar("Failed to Post")
                }

            }
        })



        binding.submitButton.setOnClickListener {

            val geocoordinate =
                "${inputLocation?.latitude}, ${inputLocation?.longitude}"

            binding.tvBuildingTypeContent.addTextChangedListener {
                binding.submitButton.enable(it.toString().isNotEmpty())
            }
            val buildType = binding.tvBuildingTypeContent.text.toString().trim()
            val address = inputLocation?.let { it1 -> setLocation(it1) }

            viewModel.submitReport(name.toString(), buildType, address.toString(), geocoordinate)
        }
    }

}