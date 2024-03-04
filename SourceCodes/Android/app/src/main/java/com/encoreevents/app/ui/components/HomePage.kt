package com.encoreevents.app.ui.components

import android.annotation.SuppressLint
import android.os.Build
import androidx.annotation.RequiresApi
import androidx.compose.foundation.Image
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.width
import androidx.compose.foundation.lazy.LazyRow
import androidx.compose.foundation.lazy.grid.GridCells
import androidx.compose.foundation.lazy.grid.LazyHorizontalGrid
import androidx.compose.foundation.lazy.grid.LazyVerticalGrid
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.selection.selectable
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.Text
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Search
import androidx.compose.material3.Icon
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.getValue
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.res.stringResource
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.style.TextDecoration
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import com.encoreevents.app.R
import com.encoreevents.app.data.model.response.ApiResponse
import com.encoreevents.app.data.model.response.categories.CategoriesData
import com.encoreevents.app.data.model.response.get_banners.BannerData
import com.encoreevents.app.data.model.response.homepage.Event
import com.encoreevents.app.data.model.response.homepage.PopularEvent
import com.encoreevents.app.ui.feature.dashboard.BannerSlider
import com.encoreevents.app.ui.feature.dashboard.DashboardViewModel
import com.encoreevents.app.ui.feature.dashboard.DotIndicator
import com.encoreevents.app.ui.theme.Orange
import com.encoreevents.app.utils.Utils.Companion.pickDate
import com.encoreevents.app.utils.Utils.Companion.showShortToast
import com.encoreevents.app.utils.Utils.Companion.timeInterval
import com.google.accompanist.pager.ExperimentalPagerApi
import com.google.accompanist.pager.rememberPagerState
import kotlinx.coroutines.delay

@RequiresApi(Build.VERSION_CODES.O)
@OptIn(ExperimentalPagerApi::class)
@Composable
fun HomePage(
    navController: NavHostController,
    mViewModel: DashboardViewModel = viewModel()
) {
    val ctx = LocalContext.current
    val pagerState = rememberPagerState()
    var showLoadingDialog by remember { mutableStateOf(true) }
    val mBannersApiResponse = mViewModel.bannersApiResponse.observeAsState().value
    val mHomepageApiResponse = mViewModel.homepageApiResponse.observeAsState().value
    val mCategoriesApiResponse = mViewModel.categoriesApiResponse.observeAsState().value
    var mBannersData: List<BannerData> = remember {
        mutableListOf()
    }
    var mPopularEvents: List<PopularEvent> = remember {
        mutableListOf()
    }
    var mUpcomingEvents: List<Event> = remember {
        mutableListOf()
    }
    var mCategories: List<CategoriesData> = remember {
        mutableListOf()
    }

    when (mBannersApiResponse) {
        is ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is ApiResponse.Success -> {
            showLoadingDialog = false
            mBannersApiResponse.data?.let {
                if (it.success) {
                    mBannersData = it.data
                }
            }
        }

        is ApiResponse.Error -> {
            showLoadingDialog = true
            showShortToast(ctx, mBannersApiResponse.errorMessage.toString())
        }

        else -> {
            showLoadingDialog = true
        }
    }

    when (mHomepageApiResponse) {
        is ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is ApiResponse.Success -> {
            showLoadingDialog = false
            mHomepageApiResponse.data?.let {
                if (it.success) {
                    mPopularEvents = it.data.popular_events
                    mUpcomingEvents = it.data.events
                }
            }
        }

        is ApiResponse.Error -> {
            showLoadingDialog = true
            showShortToast(ctx, mHomepageApiResponse.errorMessage.toString())
        }

        else -> {
            showLoadingDialog = true
        }
    }

    when (mCategoriesApiResponse) {
        is ApiResponse.Loading -> {
            if (showLoadingDialog) {
                LoadingDialog()
            }
        }

        is ApiResponse.Success -> {
            showLoadingDialog = false
            mCategoriesApiResponse.data?.let {
                if (it.success) {
                    mCategories = it.data
                }
            }
        }

        is ApiResponse.Error -> {
            showLoadingDialog = true
            showShortToast(ctx, mCategoriesApiResponse.errorMessage.toString())
        }

        else -> {
            showLoadingDialog = true
        }
    }

    Column(
        modifier = Modifier
            .fillMaxSize()
            .verticalScroll(rememberScrollState())
    ) {
        Spacer(modifier = Modifier.height(8.dp))

        if (mBannersData.isNotEmpty()) {
            BannerSlider(pagerState, mBannersData)

            Spacer(modifier = Modifier.height(4.dp))

            DotIndicator(pagerState.currentPage, totalItemCount = mBannersData.size)

            LaunchedEffect(key1 = pagerState.currentPage) {
                delay(4000)
                var newPosition = pagerState.currentPage + 1

                if (newPosition > 3) newPosition = 0

                pagerState.scrollToPage(newPosition)
            }
        }

        Spacer(modifier = Modifier.height(38.dp))

        Row(verticalAlignment = Alignment.CenterVertically) {
            CustomOutlinedTextField(
                value = mViewModel.eventDate,
                placeholder = "YYYY-MM-DD",
                enabled = false,
                modifier = Modifier
                    .weight(0.8f)
                    .clickable {
                        pickDate(mViewModel.eventDate, ctx)
                    },
                trailingIcon = {
                    Icon(
                        painter = painterResource(R.drawable.ic_calendar),
                        contentDescription = "Calender icon",
                        tint = Orange
                    )
                }
            )

            Spacer(modifier = Modifier.width(10.dp))
            CustomOutlinedTextField(
                leadingIcon = {
                    Icon(
                        Icons.Default.Search, contentDescription = "Search Icon",
                        tint = Orange
                    )
                },
                value = mViewModel.eventSearch,
                placeholder = stringResource(R.string.search_for_event_title),
                modifier = Modifier.weight(1f)
            )
            Spacer(modifier = Modifier.width(10.dp))
            GradientButton(text = "Search", wrapContentWidth = true)

        }

        HeadingText(text = stringResource(R.string.events_by_category))

        CategorySlider(mCategories) {}

        Spacer(modifier = Modifier.height(20.dp))

        // Upcoming events
        val upcomingEventCount = mUpcomingEvents.size
        LazyHorizontalGrid(
            rows = GridCells.Fixed(if (upcomingEventCount > 2) 2 else 1),
            modifier = Modifier.height(if (upcomingEventCount > 2) 300.dp else 145.dp),
            horizontalArrangement = Arrangement.spacedBy(10.dp),
            verticalArrangement = Arrangement.spacedBy(10.dp),
            content = {
                items(upcomingEventCount) { i ->
                    with(mUpcomingEvents[i]) {
                        EventCard(
                            text = event_title,
                            eventDate = timeInterval(start_date, end_date),
                            addressText = address,
                            image = image
                        )

                    }
                }
            }
        )

        HeadingText(text = stringResource(R.string.most_popular_event))

        // Popular events
        val popularEventCount = mPopularEvents.size
        LazyVerticalGrid(
            columns = GridCells.Fixed(1),
            modifier = Modifier.height((160 * popularEventCount).dp),
            verticalArrangement = Arrangement.spacedBy(10.dp),
            content = {
                items(popularEventCount) { i ->
                    with(mPopularEvents[i]) {
                        EventCard(
                            text = event_title,
                            eventDate = "May 19 - 30",
                            addressText = address,
                            image = image,
                            fullWidthCard = true
                        )

                    }
                }
            }
        )

        Spacer(modifier = Modifier.height(30.dp))

        Row {
            Column(modifier = Modifier.weight(1f)) {
                Image(
                    painter = painterResource(id = R.drawable.ic_encore_events),
                    contentDescription = "Logo",
                    modifier = Modifier.width(100.dp)
                )
                Spacer(modifier = Modifier.height(10.dp))
                WhiteText("SOY ELRATON TOUR 2022")
                WhiteText("Apr 02, 8:00 PM")
                WhiteText("CODIGOFN-NALDO PM")
                WhiteText("TOVAR-POZZIDO")
            }

            Column(modifier = Modifier.weight(1f)) {
                WhiteText(
                    "Our Company",
                    textStyle = TextStyle(fontSize = 16.sp, fontWeight = FontWeight.Bold)
                )
                WhiteText("About Us")
                WhiteText("Contact Us")
                WhiteText("Privacy Policy")
                WhiteText("Terms & Condition")
            }
        }

        Spacer(modifier = Modifier.height(20.dp))
//        WhiteText("Get weekly program and schedule subscribe our newsletter ")
        Spacer(modifier = Modifier.height(20.dp))

    }
}

@Composable
fun CategorySlider(
    categoryList: List<CategoriesData>,
    onCategorySelected: () -> Unit
) {
    LazyRow() {
        items(categoryList) { category ->
            WhiteText(
                text = category.name,
                modifier = Modifier
                    .padding(end = 9.dp)
                    .clickable { onCategorySelected() })
        }
    }
}

@SuppressLint("UnrememberedMutableState")
@Composable
fun SelectCategory(
    items: MutableList<String> = mutableListOf(
        "Category A",
        "Category B",
        "Category C"
    )
) {
    var ischecked = true
    items.add(0, "All")

    var selectedItem by remember { mutableStateOf("") }
    LazyRow {
        this.items(items = items) {
            Row(modifier = Modifier.selectable(
                selected = selectedItem == it,
                onClick = { selectedItem = it }
            )
            ) {
                if (selectedItem == "" && ischecked) {
                    Text(
                        text = items[0],
                        color = Color.Red,
                        textDecoration = TextDecoration.Underline,
                        modifier = Modifier.padding(4.dp)
                    )
                    ischecked = false
                } else if (selectedItem == it) {
                    Text(
                        text = it, color = Color.Red, textDecoration = TextDecoration.Underline,
                        modifier = Modifier.padding(4.dp)
                    )
                } else {
                    Text(it, modifier = Modifier.padding(4.dp))
                }
            }
        }
    }
}

@Preview
@Composable
fun PreviewSelectCategory() {
    SelectCategory()
}