//
//  scannerDetailModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 14/03/23.
//

import Foundation
struct ScannerDataModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: ScannerDetails?
}

// MARK: - DataClass
struct ScannerDetails: Codable {
    var id, orderID: Int?
    var ticketNo: String?
    var isChecked: Int?
    var createdAt, updatedAt: String?
    var orderData: OrderData1?

    enum CodingKeys: String, CodingKey {
        case id
        case orderID = "order_id"
        case ticketNo = "ticket_no"
        case isChecked = "is_checked"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case orderData = "order_data"
    }
}

// MARK: - OrderData
struct OrderData1: Codable {
    var id: Int?
    var orderDetails: OrderDetails1?

    enum CodingKeys: String, CodingKey {
        case id
        case orderDetails = "order_details"
    }
}

// MARK: - OrderDetails
struct OrderDetails1: Codable {
    var eventID: Int?
    var eventTitle, categoryName, eventOrganizer, eventVenue: String?
    var eventAddress, eventCity, eventZipcode, eventStartDate: String?
    var eventEndDate, eventStartTime, eventEndTime, eventImage: String?
    var eventDescription, ticketTitle, ticketType: String?
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
