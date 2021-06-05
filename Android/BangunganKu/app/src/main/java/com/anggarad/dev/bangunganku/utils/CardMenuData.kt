package com.anggarad.dev.bangunganku.utils

import com.anggarad.dev.bangunganku.data.source.local.entity.CardMenuEntity

object CardMenuData {
    fun generateMenuData(): List<CardMenuEntity> {
        val menu = ArrayList<CardMenuEntity>()

        menu.add(CardMenuEntity("menu1", "Damaged Building", "Lorem Ipsum"))

        menu.add(CardMenuEntity("menu2", "Damaged Road", "Lorem Road Ipsum"))

        return menu
    }
}