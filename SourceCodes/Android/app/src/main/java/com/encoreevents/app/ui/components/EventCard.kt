package com.encoreevents.app.ui.components

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.width
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material3.Card
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.tooling.preview.Preview
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import coil.compose.AsyncImage

@Composable
fun EventCard(
    text: String,
    modifier: Modifier = Modifier,
    eventDate: String,
    addressText: String,
    image: String,
    fullWidthCard: Boolean = false
) {
    var cardWidth = Modifier.width(180.dp)
    if (fullWidthCard) {
        cardWidth = Modifier.fillMaxWidth()
    }
    Card(
        shape = RoundedCornerShape(10.dp),
        modifier = modifier
            .then(cardWidth)
    ) {
        Column(
            modifier = Modifier
                .fillMaxWidth()
                .background(Color.White)
        ) {
            AsyncImage(
                model = image,
                contentDescription = "Event Image",
                modifier = Modifier.height(100.dp).fillMaxWidth(),
                contentScale = ContentScale.Crop
            )

            Column(modifier = Modifier.padding(horizontal = 10.dp, vertical = 4.dp)) {
                BlackText(
                    text = text,
                    textStyle = TextStyle(fontSize = 16.sp)
                )
                Row(horizontalArrangement = Arrangement.spacedBy(4.dp)) {
                    BlackText(
                        text = eventDate,
                        modifier = Modifier.weight(1f),
                        textStyle = TextStyle(fontSize = 12.sp)
                    )
                    BlackText(
                        text = addressText,
                        modifier = Modifier.weight(1f),
                        textStyle = TextStyle(fontSize = 12.sp)
                    )
                }
            }
        }
    }
}

@Preview
@Composable
fun Preview() {
    EventCard(
        text = "Hello Event",
        eventDate = "123412",
        addressText = "324sdfjnskdf ks",
        image = "https://5starglobalentertainment-qa.chetu.com/event-images/1687521828_forgot.png"
    )
}
