//
//  OrderHistoryModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 29/03/23.
//

import Foundation

// MARK: - CartModelData
struct OrderHistoryModel: Codable {
   var statusCode: Int?
   var success: Bool?
   var message: String?
   var data: [DataModelResponse]?
}
// MARK: - Order history details
struct DataModelResponse: Codable {
   var id, userID, senderID, eventID: Int?
   var orderNo, billingAddress: String?
   var orderDetails: EventOrderDetails?
   var totalPrice: Int?
   var paymentStatus: String?
   var paymentResponse: String?
   var currency: String?
   var orderPlacedDate: String?
   var totalQuantity: Int?
   var deletedAt: String?
   var createdAt, updatedAt: String?
   var user: User?

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
       case user
   }
}

// MARK: - Event Order Details
struct EventOrderDetails: Codable {
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
// MARK: - User
struct User: Codable {
    var id: Int?
    var fullName: String?

    enum CodingKeys: String, CodingKey {
        case id
        case fullName = "full_name"
    }
}
// MARK: - Payout details
struct PayoutDetails: Codable {
    var totalPayout: Int?

    enum CodingKeys: String, CodingKey {
        case totalPayout = "total_payout"
    }
}
