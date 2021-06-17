package com.anggarad.dev.bangunganku.utils

import com.anggarad.dev.bangunganku.R
import com.anggarad.dev.bangunganku.data.source.local.entity.CardMenuEntity

object CardMenuData {
    fun generateMenuData(): List<CardMenuEntity> {
        val menu = ArrayList<CardMenuEntity>()

        menu.add(CardMenuEntity("menu1",
            "Damaged Building",
            "Report the damaged buildings / public facilities in your area",
            R.drawable.ic_baseline_domain_24))

        menu.add(CardMenuEntity("menu2",
            "Damaged Road",
            "Report the damaged roads in your area",
            R.drawable.ic_baseline_edit_road_24))

        return menu
    }


}