package com.encoreevents.app.ui.components

import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.sp
import com.encoreevents.app.ui.theme.Orange

@Composable
fun TitleText(title: String, modifier: Modifier = Modifier) {
    Text(
        text = title,
        style = TextStyle(fontSize = 22.sp, fontWeight = FontWeight.SemiBold),
        color = Orange,
        textAlign = TextAlign.Center,
        modifier = modifier
    )
}