package com.anggarad.dev.bangunganku.ui.home

import androidx.lifecycle.ViewModel
import com.anggarad.dev.bangunganku.data.source.local.entity.CardMenuEntity
import com.anggarad.dev.bangunganku.utils.CardMenuData

class HomeViewModel : ViewModel() {

//    private val _cardMenuData: MutableLiveData<CardMenuEntity> = MutableLiveData()
//    val cardMenuData: LiveData<CardMenuEntity> = _cardMenuData

    fun getCardMenuData(): List<CardMenuEntity> {
        return CardMenuData.generateMenuData()
    }
}