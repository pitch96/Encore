package com.encoreevents.app.ui.components

import androidx.compose.foundation.layout.height
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardActions
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.material.OutlinedTextField
import androidx.compose.material.Text
import androidx.compose.material.TextFieldDefaults
import androidx.compose.runtime.Composable
import androidx.compose.runtime.MutableState
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.text.input.VisualTransformation
import androidx.compose.ui.text.style.TextOverflow
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.encoreevents.app.ui.theme.Orange

@Composable
fun CustomOutlinedTextField(
    value: MutableState<String>,
    modifier: Modifier = Modifier,
    enabled: Boolean = true,
    readOnly: Boolean = false,
    placeholder: String,
    leadingIcon: @Composable (() -> Unit)? = null,
    trailingIcon: @Composable (() -> Unit)? = null,
    visualTransformation: VisualTransformation = VisualTransformation.None,
    keyboardOptions: KeyboardOptions = KeyboardOptions.Default,
    keyboardActions: KeyboardActions = KeyboardActions.Default
) {
    OutlinedTextField(
        leadingIcon = leadingIcon,
        enabled = enabled,
        readOnly = readOnly,
        value = value.value,
        onValueChange = { value.value = it },
        modifier = modifier.height(46.dp),
        shape = RoundedCornerShape(10.dp),
        singleLine = true,
        maxLines = 1,
        textStyle = TextStyle(fontSize = 12.sp, color = Color.Black),
        placeholder = { Text(placeholder, overflow = TextOverflow.Ellipsis, fontSize = 10.sp) },
        colors = TextFieldDefaults.outlinedTextFieldColors(
            unfocusedBorderColor = Orange,
            focusedBorderColor = Orange,
            backgroundColor = Color.White
        ),
        trailingIcon = trailingIcon
    )
}

@Preview
@Composable
fun PreviewCustomOutlinedTextField() {
    val text = remember {
        mutableStateOf("")
    }
    CustomOutlinedTextField(text, placeholder = "Search for event title")
}