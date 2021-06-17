package com.anggarad.dev.bangunganku.ui.history

import android.annotation.SuppressLint
import android.content.res.ColorStateList
import android.view.LayoutInflater
import android.view.ViewGroup
import android.widget.LinearLayout
import androidx.recyclerview.widget.RecyclerView
import com.anggarad.dev.bangunganku.R
import com.anggarad.dev.bangunganku.data.source.remote.response.HistoryResponse
import com.anggarad.dev.bangunganku.databinding.ItemsHistoryBinding

class HistoryAdapter : RecyclerView.Adapter<HistoryAdapter.HistoryViewHolder>() {

    //    private var historyItem = emptyList<HistoryResponse>()
    private var historyItem = ArrayList<HistoryResponse>()

    fun setHistory(item: List<HistoryResponse>) {
        historyItem.clear()
        historyItem.addAll(item)
        notifyDataSetChanged()
    }

    class HistoryViewHolder(private val binding: ItemsHistoryBinding) :
        RecyclerView.ViewHolder(binding.root) {
        @SuppressLint("UseCompatLoadingForDrawables")
        fun bind(item: HistoryResponse) {
            binding.damageLevel.text = item.damageLvl
            binding.dateReport.text = item.datetime
            binding.scanType.text = item.buildtype
            if (item.status == 1) {
                binding.statusReport.text = "Processed"
                binding.statusReport.setBackgroundResource(R.drawable.background_status_proccessed)
            } else {
                binding.statusReport.text = "On Progress"

            }
            binding.reportId.text = "Laporan #${item.id}"

        }
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): HistoryViewHolder {
        val itemsHistoryBinding =
            ItemsHistoryBinding.inflate(LayoutInflater.from(parent.context), parent, false)
        return HistoryViewHolder(itemsHistoryBinding)
    }

    override fun onBindViewHolder(holder: HistoryViewHolder, position: Int) {
        val item = historyItem[position]
        holder.bind(item)
    }

    override fun getItemCount() = historyItem.size
}