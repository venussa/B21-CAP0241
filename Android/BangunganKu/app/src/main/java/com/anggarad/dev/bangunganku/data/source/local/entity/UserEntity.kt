package com.anggarad.dev.bangunganku.data.source.local.entity

import androidx.annotation.NonNull
import androidx.room.ColumnInfo
import androidx.room.Entity
import androidx.room.PrimaryKey


@Entity(tableName = "userentities")
data class UserEntity(
    @PrimaryKey
    @NonNull
    @ColumnInfo(name = "userId")
    var id: Int? = null,

    @ColumnInfo(name = "photo")
    var photo: String? = null,

    @ColumnInfo(name = "fullname")
    var fullName: String? = null,

    @ColumnInfo(name = "email")
    var email: String? = null,

    @ColumnInfo(name = "phone")
    var phone: String? = null,

    @ColumnInfo(name = "province")
    var province: String? = null,

    @ColumnInfo(name = "city")
    var city: String? = null,

    @ColumnInfo(name = "role")
    var role: String? = null,

    @ColumnInfo(name = "register_time")
    var registerTime: String? = null,

    @ColumnInfo(name = "login_time")
    var loginTime: String? = null,

    )