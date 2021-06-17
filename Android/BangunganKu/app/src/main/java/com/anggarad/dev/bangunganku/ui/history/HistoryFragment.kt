package com.anggarad.dev.bangunganku.ui.history

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.appcompat.content.res.AppCompatResources
import androidx.recyclerview.widget.DividerItemDecoration
import androidx.recyclerview.widget.LinearLayoutManager
import com.anggarad.dev.bangunganku.R
import com.anggarad.dev.bangunganku.data.network.Resource
import com.anggarad.dev.bangunganku.data.network.UserApi
import com.anggarad.dev.bangunganku.data.repository.UserRepository
import com.anggarad.dev.bangunganku.databinding.FragmentHistoryBinding
import com.anggarad.dev.bangunganku.ui.base.BaseFragment
import com.anggarad.dev.bangunganku.ui.handleApiError
import com.anggarad.dev.bangunganku.ui.visible
import kotlinx.coroutines.flow.first
import kotlinx.coroutines.runBlocking


class HistoryFragment : BaseFragment<HistoryViewModel, FragmentHistoryBinding, UserRepository>() {

    private val historyAdapter by lazy { HistoryAdapter() }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        viewModel.getUserHistory()

        setupRecycleView()



        viewModel.dataHistory.observe(viewLifecycleOwner, {
            binding.progressBar.visible(it is Resource.Loading)
            when (it) {
                is Resource.Success -> {
                    historyAdapter.setHistory(it.value)
                }
                is Resource.Failure -> handleApiError(it)

            }
        })
    }

    private fun setupRecycleView() {
        val decoration = DividerItemDecoration(requireContext(), LinearLayoutManager.HORIZONTAL)
        AppCompatResources.getDrawable(requireContext(), R.drawable.divider)
            ?.let { decoration.setDrawable(it) }

        with(binding.rvHistory) {
            layoutManager = LinearLayoutManager(context)
            setHasFixedSize(true)
            addItemDecoration(decoration)
            adapter = historyAdapter
        }
    }

    override fun getViewModel(): Class<HistoryViewModel> {
        return HistoryViewModel::class.java
    }

    override fun getFragmentBinding(
        inflater: LayoutInflater,
        container: ViewGroup?,
    ): FragmentHistoryBinding {
        return FragmentHistoryBinding.inflate(inflater, container, false)
    }

    override fun getFragmentRepos(): UserRepository {
        val token = runBlocking { userPref.accessToken.first() }
        val api = remoteDataSource.getApiService(UserApi::class.java, token)
        return UserRepository(api)
    }


}