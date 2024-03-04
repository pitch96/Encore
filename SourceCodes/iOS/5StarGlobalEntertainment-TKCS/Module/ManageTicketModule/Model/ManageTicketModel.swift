//
//  ManageTicketModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 14/02/23.
//

import Foundation
// MARK: - Manage Ticket Model
struct ManageTicketModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [ManageTicketData]?
}

// MARK: - ManageTicketData
struct ManageTicketData: Codable {
    var id, userID, eventID: Int?
    var ticketTitle: String?
    var ticketType: String?
    var quantity, noOfSoldTickets: Int?
    var price: Double?
    var endDate, endTime: String?
    var status: Int?
    var deletedAt, createdAt: String?
    var updatedAt: String?
    var ticketStatus: String?
    var event: Events?

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
        case ticketStatus = "ticket_status"
        case event
    }
}

// MARK: - Event
struct Events: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer: String?
    var venue: String?
    var address: String?
    var city: String?
    var zipcode, startDate, endDate: String?
    var startTime, endTime: String?
    var image: String?
    var description: String?
    var status: Int?
    var deletedAt: String?
    var createdAt: String?
    var updatedAt: String?

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
    }
}
// MARK: - Delete Ticket Model
struct DeleteTicketModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
   // var data: String?
}
// MARK: - Ticket Status Model
struct TicketStatusModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    //var data: [JSONAny]?
}
// MARK: - Token Expire Model
struct TokenExpireModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    
}
