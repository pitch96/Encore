package com.encoreevents.app.ui.components

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.PaddingValues
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.wrapContentWidth
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material3.Button
import androidx.compose.material3.ButtonDefaults
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.unit.Dp
import androidx.compose.ui.unit.dp
import com.encoreevents.app.ui.theme.Gradient

@Composable
fun GradientButton(
    text: String,
    modifier: Modifier = Modifier,
    wrapContentWidth: Boolean = false,
    spaceTop: Dp = 0.dp,
    spaceBottom: Dp = 0.dp,
    onClick: () -> Unit = { }
) {
    val boxWidthModifier =
        if (wrapContentWidth) Modifier.wrapContentWidth() else Modifier.fillMaxWidth()

    if (spaceTop != 0.dp) Spacer(modifier = Modifier.height(spaceTop))

    Button(
        modifier = modifier,
        colors = ButtonDefaults.buttonColors(containerColor = Color.Transparent),
        contentPadding = PaddingValues(),
        onClick = { onClick() },
        shape = RoundedCornerShape(12.dp)
    ) {
        Box(
            modifier = Modifier
                .background(Gradient)
                .then(
                    Modifier
                        .padding(horizontal = 24.dp, vertical = 8.dp)
                        .height(28.dp)
                )
                .then(boxWidthModifier),
            contentAlignment = Alignment.Center,
        ) {
            Text(text = text)
        }
    }

    if (spaceBottom != 0.dp) Spacer(modifier = Modifier.height(spaceBottom))
}