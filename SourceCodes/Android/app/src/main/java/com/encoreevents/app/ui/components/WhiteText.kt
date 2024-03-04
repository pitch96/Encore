package com.encoreevents.app.ui.components

import androidx.compose.material.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.unit.TextUnit

@Composable
fun WhiteText(
    text: String,
    modifier: Modifier = Modifier,
    textStyle: TextStyle = TextStyle(),
    fontSize: TextUnit = TextUnit.Unspecified
) {
    Text(
        text = text,
        style = textStyle,
        color = Color.White,
        modifier = modifier,
        fontSize = fontSize
    )
}