package com.anggarad.dev.bangunganku.ui.home

import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.recyclerview.widget.RecyclerView
import com.anggarad.dev.bangunganku.data.source.local.entity.CardMenuEntity
import com.anggarad.dev.bangunganku.databinding.ItemsServicesBinding
import com.anggarad.dev.bangunganku.ui.adapter.DataCallback
import com.bumptech.glide.Glide
import com.bumptech.glide.request.RequestOptions

class HomeAdapter(private val callback: DataCallback) :
    RecyclerView.Adapter<HomeAdapter.MenuViewHolder>() {

    private val listMenu = ArrayList<CardMenuEntity>()

    fun setMenu(menu: List<CardMenuEntity>?) {
        if (menu == null) return
        this.listMenu.clear()
        this.listMenu.addAll(menu)
    }

    inner class MenuViewHolder(private val binding: ItemsServicesBinding) :
        RecyclerView.ViewHolder(binding.root) {
        fun bind(menu: CardMenuEntity) {
            binding.tvServiceTitle.text = menu.serviceTitle
            binding.tvDescriptionService.text = menu.description
            Glide.with(itemView.context)
                .load(menu.logo)
                .apply(RequestOptions().override(110, 110))
                .into(binding.imageView)
            itemView.setOnClickListener {
                callback.onMenuClick(menu)
            }
        }
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): MenuViewHolder {
        val itemServiceBinding =
            ItemsServicesBinding.inflate(LayoutInflater.from(parent.context), parent, false)
        return MenuViewHolder(itemServiceBinding)
    }

    override fun onBindViewHolder(holder: MenuViewHolder, position: Int) {
        val menu = listMenu[position]
        holder.bind(menu)
    }

    override fun getItemCount(): Int {
        return listMenu.size
    }

}