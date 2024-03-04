//
//  TicketModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/12/22.
//

import Foundation

// MARK: - Welcome
struct TicketModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: tikectDataModel?
}

// MARK: - DataClass
struct tikectDataModel: Codable {
    var event: EventDetail?
    var tickets: [Ticket]?
}

// MARK: - Event
struct EventDetail: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer, venue, address, city: String?
    var zipcode, startDate, endDate, startTime: String?
    var endTime: String?
    var image: String?
    var eventDescription: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

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
        case image
        case eventDescription = "description"
        case status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}

// MARK: - Ticket
struct Ticket: Codable {
    var id, userID, eventID: Int?
    var ticketTitle, ticketType: String?
    var quantity, noOfSoldTickets : Int?
    var endDate, endTime: String?
    var status: Int?
    var deletedAt, createdAt: String?
    var updatedAt: String?
    var price: Double?

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
    }
}
