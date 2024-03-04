package com.encoreevents.app.ui.components

import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.RectangleShape
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.sp

@Composable
fun MenuItem(text: String, onClick: () -> Unit) {
    TextButton(
        onClick = { onClick() },
        modifier = Modifier.fillMaxWidth(),
        shape = RectangleShape
    ) {
        Text(
            text = text,
            modifier = Modifier.weight(1f),
            fontSize = 18.sp,
            fontWeight = FontWeight.Normal
        )
    }
}