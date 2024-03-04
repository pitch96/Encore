package com.encoreevents.app.ui.components

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxHeight
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.heightIn
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.layout.width
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.BasicTextField
import androidx.compose.foundation.text.KeyboardActions
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.material3.ButtonDefaults
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.MutableState
import androidx.compose.ui.Alignment
import androidx.compose.ui.ExperimentalComposeUiApi
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.SolidColor
import androidx.compose.ui.platform.LocalSoftwareKeyboardController
import androidx.compose.ui.platform.SoftwareKeyboardController
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.text.input.VisualTransformation
import androidx.compose.ui.unit.Dp
import androidx.compose.ui.unit.dp

//Custom TextField for reuse in different screens: -
@OptIn(ExperimentalComposeUiApi::class)
@Composable
fun CustomTextField(
    value: MutableState<String>,
    modifier: Modifier = Modifier,
    enabled: Boolean = true,
    readOnly: Boolean = false,
    maxLength: Int? = null,
    textStyle: TextStyle = TextStyle.Default,
    keyboardOptions: KeyboardOptions = KeyboardOptions.Default,
    keyboardActions: KeyboardActions = KeyboardActions.Default,
    singleLine: Boolean = true,
    maxLines: Int = 1,
    minLines: Int = 1,
    visualTransformation: VisualTransformation = VisualTransformation.None,
    cursorBrush: Brush = SolidColor(Color.Black),
    isError: Boolean = false,
    placeholder: String,
    leadingIcon: @Composable (() -> Unit)? = null,
    trailingIcon: @Composable (() -> Unit)? = null,
    spaceTop: Dp = 0.dp,
    spaceBottom: Dp = 0.dp,
    keyBoardController: SoftwareKeyboardController? = LocalSoftwareKeyboardController.current
) {
    Spacer(modifier = Modifier.height(spaceTop))

    Row(
        modifier = modifier
            .background(
                color = Color.White, shape = RoundedCornerShape(10.dp)
            )
            .padding(horizontal = 12.dp, vertical = 8.dp)
            .fillMaxWidth()
            .heightIn(min = 30.dp),
        verticalAlignment = Alignment.CenterVertically
    ) {
        if (leadingIcon != null) {
            leadingIcon()
            Spacer(modifier = Modifier.size(ButtonDefaults.IconSpacing))
            Box(
                modifier = Modifier
                    .background(color = Color.Gray)
                    .width(1.dp)
                    .fillMaxHeight()
            )
            Spacer(modifier = Modifier.size(ButtonDefaults.IconSpacing))
        }
        BasicTextField(
            modifier = Modifier.weight(1f),
            maxLines = maxLines,
            minLines = minLines,
            singleLine = singleLine,
            value = value.value,
            enabled = enabled,
            onValueChange = {
                if (maxLength != null) {
                    if (it.length <= maxLength) value.value = it
                } else value.value = it
            },
            visualTransformation = visualTransformation,
            keyboardOptions = keyboardOptions,
            keyboardActions = keyboardActions,
            decorationBox = { innerTextField ->
                if (value.value.isEmpty()) {
                    Text(text = placeholder, color = Color.LightGray)
                }
                innerTextField()
            })
        if (trailingIcon != null) {
            Spacer(modifier = Modifier.size(ButtonDefaults.IconSpacing))
            trailingIcon()
        }
    }

    Spacer(modifier = Modifier.height(spaceBottom))
}