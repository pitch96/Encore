//
//  GuestListModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 07/04/23.
//

import Foundation

// MARK: - Guest list Model
struct GuestListModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [GuestListDetail]?
}

// MARK: - Datum
struct GuestListDetail: Codable {
    var id, userID, senderID, eventID: Int?
    var orderNo, billingAddress: String?
    var orderDetails: OrderDetails1?
    var totalPrice: Int?
    var paymentStatus, paymentResponse, currency, orderPlacedDate: String?
    var totalQuantity: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?
    var ticketsChecked: Int?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case senderID = "sender_id"
        case eventID = "event_id"
        case orderNo = "order_no"
        case billingAddress = "billing_address"
        case orderDetails = "order_details"
        case totalPrice = "total_price"
        case paymentStatus = "payment_status"
        case paymentResponse = "payment_response"
        case currency
        case orderPlacedDate = "order_placed_date"
        case totalQuantity = "total_quantity"
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case ticketsChecked
    }
}
// MARK: - OrderDetails
struct OrderDetails1: Codable {
    var eventID: Int?
    var eventTitle, categoryName, eventOrganizer, eventVenue: String?
    var eventAddress, eventCity, eventZipcode, eventStartDate: String?
    var eventEndDate, eventStartTime, eventEndTime: String?
    var eventImage: String?
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
