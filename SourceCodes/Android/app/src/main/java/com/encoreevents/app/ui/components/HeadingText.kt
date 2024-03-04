package com.encoreevents.app.ui.components

import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.material.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontStyle
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.text.style.TextOverflow
import androidx.compose.ui.unit.TextUnit
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.encoreevents.app.ui.theme.Orange

@Composable
fun HeadingText(
    text: String,
    modifier: Modifier = Modifier,
    color: Color = Orange,
    fontSize: TextUnit = 18.sp,
    fontStyle: FontStyle? = null,
    fontWeight: FontWeight? = FontWeight.Bold,
    textAlign: TextAlign? = TextAlign.Center,
    overflow: TextOverflow = TextOverflow.Clip,
    maxLines: Int = Int.MAX_VALUE,
) {
    Spacer(modifier = Modifier.height(30.dp))
    Text(
        text = text,
        color = color,
        modifier = modifier.fillMaxWidth(),
        textAlign = textAlign,
        maxLines = maxLines,
        overflow = overflow,
        fontSize = fontSize,
        fontWeight = fontWeight,
        fontStyle = fontStyle
    )
    Spacer(modifier = Modifier.height(20.dp))
}