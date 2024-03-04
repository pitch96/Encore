//
//  CartModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 11/01/23.
//

import Foundation

struct CartModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: CartData?
}

// MARK: - DataClass
struct CartData: Codable {
    var userID, ticketID, quantity, updatedAt: String?
    var createdAt: String?
    var id: Int?

    enum CodingKeys: String, CodingKey {
        case userID = "user_id"
        case ticketID = "ticket_id"
        case quantity
        case updatedAt = "updated_at"
        case createdAt = "created_at"
        case id
    }
}

// MARK: - CartModelData
struct CartModelData: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: CartDetail?
}

// MARK: - DataClass
struct CartDetail: Codable {
    var cartDatas: [GetCartData]?
    var activeAddress: ActiveAddress?
    var allAddress: [JSONAny]?

    enum CodingKeys: String, CodingKey {
        case cartDatas
        case activeAddress = "active_address"
        case allAddress = "all_address"
    }
}

// MARK: - ActiveAddress
struct ActiveAddress: Codable {
    var id, userID: Int?
    var fullName, phoneNo, email, zipcode: String?
    var state, city, address: String?
    var active: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case fullName = "full_name"
        case phoneNo = "phone_no"
        case email, zipcode, state, city, address, active
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}

// MARK: - CartData
struct GetCartData: Codable {
    var id, userID, ticketID, quantity: Int?
    var createdAt, updatedAt: String?
    var ticket: Ticket1?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case ticketID = "ticket_id"
        case quantity
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case ticket
    }
}

// MARK: - Ticket
struct Ticket1: Codable {
    var id, userID, eventID: Int?
    var ticketTitle, ticketType: String?
    var quantity, noOfSoldTickets: Int?
    var price: Double?
    var endDate, endTime: String?
    var status: Int?
    var deletedAt, createdAt, updatedAt: String?
    var event: Event1?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case eventID = "event_id"
        case ticketTitle = "ticket_title"
        case ticketType = "ticket_type"
        case quantity
        case noOfSoldTickets = "no_of_sold_tickets"
        case price
        case endDate = "end_date"
        case endTime = "end_time"
        case status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case event
    }
}

// MARK: - Event
struct Event1: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer, venue, address, city: String?
    var zipcode, startDate, endDate, startTime: String?
    var endTime, image, description: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?
    var eventImage: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case eventTitle = "event_title"
        case categoryID = "category_id"
        case organizer, venue, address, city, zipcode
        case startDate = "start_date"
        case endDate = "end_date"
        case startTime = "start_time"
        case endTime = "end_time"
        case image, description, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case eventImage = "event_image"
    }
}
struct DeleteCart: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: String?
}
struct PlacedOrder: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
//    var data: String?
}
struct UpdateCart: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: UpdateCartData?
}

// MARK: - DataClass
struct UpdateCartData: Codable {
    var id, userID, ticketID: Int?
    var quantity, createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case ticketID = "ticket_id"
        case quantity
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}


// MARK: - ActiveAddress
struct ActiveAddressDetails {
    var id : Int?
    var fullName, phoneNo, email, zipcode: String?
    var state, city, address: String?
 
}
