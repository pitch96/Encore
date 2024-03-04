//
//  MyOrdersModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 29/12/22.
//

import Foundation
struct OrderModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [OrderDetail]?
}

// MARK: - Datum
struct OrderDetail: Codable {
    var id: Int?
    var orderDetails: OrderDetails?
    var orderPlacedDate: String?
    var totalQuantity, totalPrice: Int?

    enum CodingKeys: String, CodingKey {
        case id
        case orderDetails = "order_details"
        case orderPlacedDate = "order_placed_date"
        case totalQuantity = "total_quantity"
        case totalPrice = "total_price"
    }
}

// MARK: - OrderDetails
struct OrderDetails: Codable {
    var eventID: Int?
    var eventTitle: String?
    var categoryName: String?
    var eventOrganizer: String?
    var eventVenue: String?
    var eventAddress: String?
    var eventCity: String?
    var eventZipcode, eventStartDate, eventEndDate: String?
    var eventStartTime: String?
    var eventEndTime: String?
    var eventImage: String?
    var eventDescription: String?
    var ticketTitle: String?
    var ticketType: String?
    var ticketPrice, ticketPurchaseQty, totalPrice: Int?

    enum CodingKeys: String, CodingKey {
        case eventID = "event_id"
        case eventTitle = "event_title"
        case categoryName = "category_name"
        case eventOrganizer = "event_organizer"
        case eventVenue = "event_venue"
        case eventAddress = "event_address"
        case eventCity = "event_city"
        case eventZipcode = "event_zipcode"
        case eventStartDate = "event_start_date"
        case eventEndDate = "event_end_date"
        case eventStartTime = "event_start_time"
        case eventEndTime = "event_end_time"
        case eventImage = "event_image"
        case eventDescription = "event_description"
        case ticketTitle = "ticket_title"
        case ticketType = "ticket_type"
        case ticketPrice = "ticket_price"
        case ticketPurchaseQty = "ticket_purchase_qty"
        case totalPrice = "total_price"
    }
}

