package com.anggarad.dev.bangunganku.ui.adapter

import com.anggarad.dev.bangunganku.data.source.local.entity.CardMenuEntity

interface DataCallback {
    fun onMenuClick(data: CardMenuEntity)
}