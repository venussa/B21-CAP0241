package com.anggarad.dev.bangunganku.ui.service.building

import android.app.Activity
import android.content.Intent
import android.location.Location
import android.net.Uri
import android.os.Bundle
import android.os.Environment
import android.provider.MediaStore
import android.view.View
import android.widget.Toast
import androidx.activity.result.contract.ActivityResultContracts.StartActivityForResult
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.FileProvider
import androidx.fragment.app.FragmentTransaction
import androidx.lifecycle.ViewModelProvider
import androidx.lifecycle.lifecycleScope
import com.anggarad.dev.bangunganku.R
import com.anggarad.dev.bangunganku.data.UserPreferences
import com.anggarad.dev.bangunganku.data.network.ApiService
import com.anggarad.dev.bangunganku.data.network.RemoteDataSource
import com.anggarad.dev.bangunganku.data.network.Resource
import com.anggarad.dev.bangunganku.data.network.UploadRequestBody
import com.anggarad.dev.bangunganku.data.repository.ReportRepository
import com.anggarad.dev.bangunganku.databinding.ActivityServiceReportBinding
import com.anggarad.dev.bangunganku.ui.*
import com.anggarad.dev.bangunganku.viewmodel.ViewModelFactory
import com.bumptech.glide.Glide
import com.bumptech.glide.load.resource.bitmap.CenterCrop
import com.bumptech.glide.load.resource.bitmap.RoundedCorners
import com.bumptech.glide.request.RequestOptions
import kotlinx.coroutines.Job
import kotlinx.coroutines.flow.first
import kotlinx.coroutines.launch
import kotlinx.coroutines.runBlocking
import java.io.File
import java.io.FileInputStream
import java.io.FileOutputStream
import java.util.*


class ServiceReportActivity : AppCompatActivity(), UploadRequestBody.UploadCallback {

    private lateinit var binding: ActivityServiceReportBinding
    private lateinit var userPref: UserPreferences
    private lateinit var viewModel: ServiceReportViewModel
    private val remoteDataSource = RemoteDataSource()
    lateinit var photoFile: File
    private var imageToProcess: Uri? = null
    private lateinit var location: Location
    private lateinit var transaction: FragmentTransaction


    companion object {
        const val TYPE_BUILDING = "type_building"
        const val EXTRA_LOCATION = "extra_location"
        const val FILE_NAME = "photo.jpg"

    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityServiceReportBinding.inflate(layoutInflater)
        setContentView(binding.root)


        userPref = UserPreferences(this@ServiceReportActivity)

        val factory = ViewModelFactory(getRepository())
        viewModel = ViewModelProvider(this, factory).get(ServiceReportViewModel::class.java)
        supportActionBar?.setDisplayHomeAsUpEnabled(true)
        supportActionBar?.setDisplayShowHomeEnabled(true)

        userPref = UserPreferences(this)
        val type = intent.getStringExtra(TYPE_BUILDING)
        location = intent.getParcelableExtra(EXTRA_LOCATION)!!

        binding.progressBar.visible(false)

        binding.damageType.visible(false)


        transaction = this.supportFragmentManager.beginTransaction()
//        val reportFragment = ReportFragment()
//        val blankFragment = BlankFragment()
//        reportFragment.arguments = bundle

//        transaction.add(R.id.report_container, blankFragment)
//
//        binding.button2.setOnClickListener {
//            transaction.replace(R.id.report_container, reportFragment)
//            transaction.setTransition(FragmentTransaction.TRANSIT_FRAGMENT_OPEN)
//            transaction.commit()
//        }


        if (type.equals("menu2", ignoreCase = true)) {
            supportActionBar?.title = "Report Damaged Road"

            val cameraLauncher = registerForActivityResult(StartActivityForResult()) { result ->
                if (result.resultCode == Activity.RESULT_OK) {
                    val body = UploadRequestBody(photoFile, "image", this)
                    predictFunction(viewModel.scanRoad(photoFile.name, body))

                    Glide.with(binding.root)
                        .load(imageToProcess)
                        .apply(RequestOptions
                            .overrideOf(190, 190)
                            .transform(CenterCrop(), RoundedCorners(20)))
                        .into(binding.servicePhoto)



                }

            }

            binding.btnTakePicture.setOnClickListener {

                val takePictureIntent = Intent(MediaStore.ACTION_IMAGE_CAPTURE)
                photoFile = getPhotoFile(FILE_NAME)

                imageToProcess =
                    FileProvider.getUriForFile(this, "com.anggarad.dev.fileprovider", photoFile)
                takePictureIntent.putExtra(MediaStore.EXTRA_OUTPUT, imageToProcess)
                cameraLauncher.launch(takePictureIntent)


            }

        }

        if (type.equals("menu1", ignoreCase = true)) {
            supportActionBar?.title = "Report Damaged Building"

            var cameraLauncher = registerForActivityResult(StartActivityForResult()) { result ->
                if (result.resultCode == Activity.RESULT_OK) {
                    val body = UploadRequestBody(photoFile, "image", this)
                    predictFunction(viewModel.scanBuilding(photoFile.name, body))

                    Glide.with(binding.root)
                        .load(imageToProcess)
                        .apply(RequestOptions
                            .overrideOf(190, 190)
                            .transform(CenterCrop(), RoundedCorners(20)))
                        .into(binding.servicePhoto)
                }

            }

            binding.btnTakePicture.setOnClickListener {
                val takePictureIntent = Intent(MediaStore.ACTION_IMAGE_CAPTURE)
                photoFile = getPhotoFile(FILE_NAME)

                imageToProcess =
                    FileProvider.getUriForFile(this, "com.anggarad.dev.fileprovider", photoFile)
                takePictureIntent.putExtra(MediaStore.EXTRA_OUTPUT, imageToProcess)
                cameraLauncher.launch(takePictureIntent)

            }

        }


    }

    private fun getRepository(): ReportRepository {
        val token = runBlocking { userPref.accessToken.first() }
        val api = remoteDataSource.getApiScan(ApiService::class.java, token)
        return ReportRepository(api, userPref)

    }

    private fun getPhotoFile(photoName: String): File {
        val storageDirectory = getExternalFilesDir(Environment.DIRECTORY_PICTURES)
        return File.createTempFile(photoName, ".jpg", storageDirectory)
    }

    private fun predictFunction(viewModelFunc: Job): Job {
        viewModel.scanResponse.observe(this, {
            binding.progressBar.visible(it is Resource.Loading)
            when (it) {
                is Resource.Success -> {
                    if (!it.value.response) {
                        Toast.makeText(this,
                            "${it.value.message}, Please Try Again",
                            Toast.LENGTH_SHORT)
                            .show()
                    } else {
                        lifecycleScope.launch {
                            viewModel.getProcessToken(it.value.processToken!!)
                        }
                        Toast.makeText(this, it.value.message, Toast.LENGTH_SHORT).show()
                        binding.damageType.visible(true)
                        binding.damageType.text = it.value.damageLevel
                        binding.tvReportDate.text = it.value.dateTime
                        val newProcessToken = it.value.processToken

                        binding.btnTakePicture.enable(false)

                        val bundle = Bundle()
                        bundle.putParcelable("location", location)
                        bundle.putString("processToken", newProcessToken)

                        val reportFragment = ReportFragment()
                        reportFragment.arguments = bundle

                        transaction.add(R.id.report_container, reportFragment)
                        transaction.setTransition(FragmentTransaction.TRANSIT_FRAGMENT_OPEN)
                        transaction.commit()

                    }
                }

                is Resource.Failure -> {
                    if (it.isNetworkError) {
                        binding.root.snackbar("Network Error")
                        //Toast.makeText(this, "Network Error", Toast.LENGTH_SHORT).show()
                    } else if (it.errorCode == 500) {
                        binding.root.snackbarDismiss("Server Error")
                    } else {
                        Toast.makeText(this, it.errorBody.toString(), Toast.LENGTH_SHORT).show()
                    }
                }
            }
        })


        return viewModelFunc
    }

    private fun uploadImage() {
        if (imageToProcess == null) {
            binding.root.snackbarDismiss("Please Upload an Image First")
            return
        }

        val parcelFileDescriptor =
            contentResolver.openFileDescriptor(imageToProcess!!, "r", null) ?: return
        val file = File(cacheDir, contentResolver.getFileName(imageToProcess!!))
        val inputStream = FileInputStream(parcelFileDescriptor.fileDescriptor)
        val outputStream = FileOutputStream(file)
        inputStream.copyTo(outputStream)

        val body = UploadRequestBody(file, "image", this)
    }

    override fun onProgressUpdate(percentage: Int) {

    }
}