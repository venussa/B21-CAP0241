package com.anggarad.dev.bangunganku.data.network

import android.os.Handler
import android.os.Looper
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.RequestBody
import okio.BufferedSink
import java.io.File
import java.io.FileInputStream

class UploadRequestBody(
    private val file: File,
    private val contentType: String,
    private val callback: UploadCallback,
) : RequestBody() {

    interface UploadCallback {
        fun onProgressUpdate(percentage: Int)
    }

    inner class ProgressUpdate(
        private val uploaded: Long,
        private val total: Long,
    ) : Runnable {
        override fun run() {
            callback.onProgressUpdate((100 * uploaded / total).toInt())
        }

    }

    override fun contentType() = "$contentType/*".toMediaTypeOrNull()

    override fun contentLength(): Long {
        return file.length()
    }

    override fun writeTo(sink: BufferedSink) {
        val length = file.length()
        val buffer = ByteArray(DEFAULT_BUFFER_SIZE)
        val fileinputStream = FileInputStream(file)
        var uploaded = 0L

        fileinputStream.use { inputStream ->
            var read: Int
            val handler = Handler(Looper.getMainLooper())

            while (inputStream.read(buffer).also { read = it } != -1) {
                handler.post(ProgressUpdate(uploaded, length))
                uploaded += read
                sink.write(buffer, 0, read)
            }
        }
    }

    companion object {
        private const val DEFAULT_BUFFER_SIZE = 1048
    }

}