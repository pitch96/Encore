package com.encoreevents.app.ui.components

import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.encoreevents.app.ui.theme.Orange

@Composable
fun SubHeadingText(name: String) {
    Text(
        modifier = Modifier.padding(start = 5.dp),
        text = name,
        style = TextStyle(
            textAlign = TextAlign.Start,
            fontSize = 16.sp,
            fontWeight = FontWeight.Bold,
        ),
        color = Orange
    )
    Spacer(modifier = Modifier.height(6.dp))
}