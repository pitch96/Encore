package com.encoreevents.app.ui.components

import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.selection.selectable
import androidx.compose.material3.RadioButton
import androidx.compose.material3.RadioButtonDefaults
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.semantics.Role
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.unit.dp

@Composable
fun CustomHorizontalRadioGroup(
    radioOptions: List<String>,
    selectedOption: String,
    setSelectedOption: (selectedOption: String) -> Unit
) {
    Row(modifier = Modifier.fillMaxWidth(), verticalAlignment = Alignment.CenterVertically) {
        radioOptions.forEach { currentOption ->
            Row(
                modifier = Modifier
                    .weight(1f)
                    .selectable(
                        selected = (selectedOption == currentOption),
                        onClick = {
                            setSelectedOption(currentOption)
                        },
                        role = Role.RadioButton
                    ),
                verticalAlignment = Alignment.CenterVertically
            ) {
                RadioButton(
                    modifier = Modifier
                        .padding(end = 8.dp)
                        .height(36.dp),
                    selected = selectedOption == currentOption,
                    onClick = null,
//                    enabled = true,
                    colors = RadioButtonDefaults.colors(selectedColor = Color.White)
                )
                Text(text = currentOption, style = TextStyle(color = Color.White))
            }
        }
    }
}