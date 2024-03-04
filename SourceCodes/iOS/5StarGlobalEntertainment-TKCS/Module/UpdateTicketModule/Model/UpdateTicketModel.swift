//
//  UpdateTicketModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 16/02/23.
//

import Foundation
// MARK: - Update Ticket Model
struct UpdateTicketModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: ticketDetails?
}

// MARK: - ticketDetails
struct ticketDetails: Codable {
    var events: [String: String]?
    var ticket: TicketData?
}

// MARK: - TicketData
struct TicketData: Codable {
    var id, userID, eventID: Int?
    var ticketTitle, ticketType: String?
    var quantity, noOfSoldTickets, price: Int?
    var endDate, endTime: String?
    var status: Int?
    var deletedAt, createdAt: String?
    var updatedAt: String?

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
