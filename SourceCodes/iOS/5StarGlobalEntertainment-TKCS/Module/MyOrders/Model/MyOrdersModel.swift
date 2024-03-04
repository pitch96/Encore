//
//  MyOrdersModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 29/12/22.
//

import Foundation

struct MyOrdersModel {
    var EventData: [MyEventData]
}

struct MyEventData {
    var eventTitle: String
    var ticketTitle: String
    var ticketType: String
    var quantity: Int
    var price: Double
    var totalPrice: Double
    var date: String
}
