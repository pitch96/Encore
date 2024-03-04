//
//  EventOrderModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/04/23.
//

import Foundation
// MARK: Expired Event Order Model
struct EventOrderModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [EventOrderData]?
}

// MARK: - Datum
struct EventOrderData: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer, venue, address, city: String?
    var zipcode, startDate, endDate, startTime: String?
    var endTime, image, description: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?
    var ticketsSold: TicketsSold?
    var revenue: Revenue?
    var order: [Order1]?
    var eventStatus: String?
    var guestCount: Int?

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
        case ticketsSold = "tickets_sold"
        case revenue, order
        case eventStatus = "event_status"
        case guestCount
    }
}

// MARK: - Order
struct Order1: Codable {
    var id: Int?
    var firstName, lastName: String?
    var userProfile: String?
    var orderDetails, orderPlacedDate: String?

    enum CodingKeys: String, CodingKey {
        case id
        case firstName = "first_name"
        case lastName = "last_name"
        case userProfile = "user_profile"
        case orderDetails = "order_details"
        case orderPlacedDate = "order_placed_date"
    }
}

// MARK: - Revenue
struct Revenue: Codable {
    var revenueGenerated: Int?

    enum CodingKeys: String, CodingKey {
        case revenueGenerated = "revenue_generated"
    }
}

// MARK: - TicketsSold
struct TicketsSold: Codable {
    var ticketsSold: String?

    enum CodingKeys: String, CodingKey {
        case ticketsSold = "tickets_sold"
    }
}

// MARK: - Running event Model
struct RunningDataModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [RunningeEventDetail]?
}

// MARK: - Datum
struct RunningeEventDetail: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer, venue, address, city: String?
    var zipcode, startDate, endDate, startTime: String?
    var endTime, image, description: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?
    var ticketsSold: TicketsSold1?
    var revenue: Revenue1?
    var order: [Order]?
    var eventStatus: String?
    var guestCount: Int?

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
        case ticketsSold = "tickets_sold"
        case revenue, order
        case eventStatus = "event_status"
        case guestCount
    }
}

// MARK: - Order
struct Order: Codable {
    var id: Int?
    var firstName, lastName: String?
    var userProfile: String?
    var orderDetails, orderPlacedDate: String?

    enum CodingKeys: String, CodingKey {
        case id
        case firstName = "first_name"
        case lastName = "last_name"
        case userProfile = "user_profile"
        case orderDetails = "order_details"
        case orderPlacedDate = "order_placed_date"
    }
}

// MARK: - Revenue
struct Revenue1: Codable {
    var revenueGenerated: Int?

    enum CodingKeys: String, CodingKey {
        case revenueGenerated = "revenue_generated"
    }
}

// MARK: - TicketsSold
struct TicketsSold1: Codable {
    var ticketsSold: String?

    enum CodingKeys: String, CodingKey {
        case ticketsSold = "tickets_sold"
    }
}
