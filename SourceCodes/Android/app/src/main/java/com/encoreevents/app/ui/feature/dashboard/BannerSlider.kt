package com.encoreevents.app.ui.feature.dashboard

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.layout.wrapContentHeight
import androidx.compose.foundation.lazy.LazyRow
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.Color.Companion.Black
import androidx.compose.ui.graphics.Color.Companion.White
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.core.text.HtmlCompat
import coil.compose.AsyncImage
import com.encoreevents.app.data.model.response.get_banners.BannerData
import com.encoreevents.app.ui.theme.Orange
import com.encoreevents.app.ui.theme.Pink
import com.google.accompanist.pager.ExperimentalPagerApi
import com.google.accompanist.pager.HorizontalPager
import com.google.accompanist.pager.PagerState

@OptIn(ExperimentalPagerApi::class)
@Composable
fun BannerSlider(
    state: PagerState,
    bannersData: List<BannerData>
) {
    HorizontalPager(
        count = bannersData.size,
        state = state,
        itemSpacing = 8.dp
    ) { page ->
        Box(
            modifier = Modifier
                .fillMaxWidth()
                .height(200.dp)
        ) {
            val imgUrl = bannersData[page].banner_image
            val description = HtmlCompat.fromHtml(bannersData[page].description, 0)
            AsyncImage(
                model = imgUrl,
                contentDescription = null,
                modifier = Modifier
                    .fillMaxWidth()
                    .height(200.dp),
                contentScale = ContentScale.Crop
            )
            Column(
                modifier = Modifier
                    .fillMaxSize()
                    .padding(30.dp)
                    .background(
                        brush = Brush.horizontalGradient(
                            colors = listOf(
                                Orange.copy(alpha = 0.15f),
                                Pink.copy(alpha = 0.15f)
                            )
                        )
                    )
                    .padding(4.dp)
            ) {
                Text(
                    text = description.toString(),
                    fontSize = 22.sp, fontWeight = FontWeight.Bold
                )
            }
        }
    }
}

@Composable
fun DotIndicator(currentIndex: Int, totalItemCount: Int = 4) {
    LazyRow(
        modifier = Modifier
            .fillMaxWidth()
            .wrapContentHeight(),
        horizontalArrangement = Arrangement.Center
    ) {
        items(totalItemCount) { index ->
            if (index == currentIndex) {
                IndicatorDot(White)
            } else {
                IndicatorDot(Black)
            }

            if (index != totalItemCount - 1) {
                Spacer(modifier = Modifier.padding(horizontal = 4.dp))
            }
        }
    }
}

@Composable
fun IndicatorDot(color: Color) {
    Box(
        modifier = Modifier
            .size(8.dp)
            .clip(CircleShape)
            .background(color = color)
    )
}

@OptIn(ExperimentalPagerApi::class)
@Preview
@Composable
fun PreviewBannerSlider() {
    BannerSlider(state = PagerState(0), bannersData = emptyList())
}