package com.encoreevents.app.ui.components

import androidx.compose.material.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.text.style.TextOverflow

@Composable
fun BlackText(
    text: String,
    modifier: Modifier = Modifier,
    textStyle: TextStyle = TextStyle(),
    maxLines: Int = 1,
    overFlow: TextOverflow = TextOverflow.Ellipsis
) {
    Text(
        text = text,
        style = textStyle,
        color = Color.Black,
        modifier = modifier,
        maxLines = maxLines,
        overflow = overFlow
    )
}